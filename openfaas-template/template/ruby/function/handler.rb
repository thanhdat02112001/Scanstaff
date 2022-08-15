class Handler
  def run(data)
    # write to file
    File.write("/home/app/solution_#{data["sid"]}.rb", data["body"])
    require "/home/app/solution_#{data["sid"]}.rb"
  end
end
